<?php

namespace App\Http\Controllers;

use Cache;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Groups.
     *
     * @var array
     */
    protected $groups = [];

    /**
     * Links to search the groups.
     *
     * @var array
     */
    protected $urls = [
        'grupos' => 'http://campuse.ro/events/CPBR10-Grupos/workshop',
    ];

    /**
     * Time to store info in cache.
     * 2 hours.
     *
     * @var int
     */
    protected $cache_time = 60 * 2;

    public function index()
    {
        // If the user clicks on refresh button, this condition becomes true.
        if (isset($_GET['update'])) {
            // Clear the entire cache.
            Cache::flush();

            // Redirect to home route (and run this script again).
            return redirect()->route('home');
        }

        // Stores the last time this script was run.
        $last_sync = Cache::remember('last_sync', $this->cache_time, function () {
            return Carbon::now();
        });

        // Transform array to Laravel Collection.
        $this->groups = collect($this->groups);

        // Get the urls.
        $urls = $this->urls;

        // Create an empty collection for all tags.
        $all_tags = collect([]);

        // If there are no groups in the cache.
        if (!Cache::has('groups')) {
            // For each URL..
            foreach ($urls as $key => $url) {
                // Number of pages.
                $campusero_pages_init = file_get_contents($url);
                $content_pages_dirty = $this->between('<div class="pagination text-center">', "</div>\n</div>", $campusero_pages_init);
                $content_pages_find = '<a href="';
                $content_pages = collect(explode($content_pages_find, $content_pages_dirty));
                $times = $content_pages->count() - 2;

                // For each page..
                for ($page = 1; $page <= $times; $page++) {
                    // Get the html content of the page.
                    $campusero_page = file_get_contents($url.'?page='.$page);

                    // Break the content.
                    $contents = explode('profile-activities-panel', $campusero_page)[2];
                    $list = explode('events-list', $contents)[1];
                    $xablau1 = explode('row collapse table-header light-theme', $list)[1];
                    $all = collect(explode('row collapse table-body light-theme', $xablau1));

                    // After breaking, all groups are in $all, but still in html.
                    foreach ($all as $k => $single) {
                        // The first occurrence isn't a activity, so let's skip it.
                        if ($k != 0) {
                            // Sanitize, remove the html.
                            $content_tags = $this->between('<div class="large-2 text-right columns">', '</div></div>', $single);
                            $content_tags_div = '<div class="text-right activity-tag">';
                            $content_tags_dirty = explode($content_tags_div, $content_tags);

                            // Count how many tags have.
                            $tags_num = collect($content_tags_dirty)->count() - 1;

                            // Create an empty collection for all groups tags.
                            $tags = collect([]);
                            for ($i = 1; $i <= $tags_num; $i++) {
                                // Sanitize, remove the html.
                                $tag = str_replace('</div>', '', $content_tags_dirty[$i]);
                                $tag = str_replace("\n", '', $tag);
                                $slug = str_slug($tag);

                                // Add tag into groups $tags collection.
                                $tags->put($slug, $tag);

                                // If this tag has not yet been registered..
                                if (!$all_tags->has($slug)) {
                                    // Add tag into $all_tags.
                                    $all_tags->put($slug, [
                                        'name'   => $tag,
                                        'amount' => 1,
                                    ]);
                                } else {
                                    // If all tags have not yet been saved.
                                    if (!Cache::has('all_tags')) {
                                        // Add your occurrence to +1 (like couting how many tags have).
                                        $all_tags->transform(function ($item, $key) use ($slug) {
                                            if ($key == $slug) {
                                                $amount = $item['amount'];
                                                $amount++;

                                                $collection = collect($item)->forget('amount');
                                                $collection->put('amount', $amount);

                                                return $collection->toArray();
                                            }

                                            return $item;
                                        });
                                    }
                                }
                            }

                            // the activity link.
                            $link = 'http://campuse.ro'.$this->between('<strong><a href="', '">', $single);

                            // the activity title.
                            $title = explode('">', $single)[3];
                            $title = explode('</a>', $title)[0];

                            // bug
                            $wtf = '*__cf_email__*';
                            $oh_boy = 'Caravana> lavras@CPBR:~$';
                            if (str_is($wtf, $title)) {
                                $title = $oh_boy;
                            }

                            // the number of subscribers in the activity.
                            $subscribers = $this->between('<span class="attendees right">', '</span>', $single);

                            // the activity.
                            $group = [
                                'link'        => $link,
                                'title'       => $title,
                                'subscribers' => $subscribers,
                                'type'        => $key,
                                'tags'        => $tags,
                            ];

                            // Add the activity in the collection of groups.
                            $this->groups->push($group);
                        }
                    }
                }
            }
        }

        // Stores all tags. For don't process the script again.
        $all_tags = Cache::remember('all_tags', $this->cache_time, function () use ($all_tags) {
            return $all_tags;
        });

        // Verify if have to filter by tag.
        $filter_tag = (isset($_GET['tag'])) ? $_GET['tag'] : null;

        $groups = $this->groups->sortByDesc('subscribers');

        // If all groups haven't been saved yet.
        if (!Cache::has('groups')) {
            // Check the position of each activity.
            $i = 0;
            $groups->transform(function ($item, $key) use ($i) {
                $this->i = (isset($this->i)) ? $this->i : $i;
                $this->i++;
                $item['position'] = $this->i;

                return $item;
            });
        }

        // Stores all groups. For don't process the script again.
        $groups = Cache::remember('groups', $this->cache_time, function () use ($groups) {
            // Sort/Order by quantity of subscribers.
            return $groups;
        });

        // If have to filter by tag.
        if (!is_null($filter_tag)) {
            // Return only groups have the tag.
            $groups = $groups->filter(function ($value, $key) use ($filter_tag) {
                return $value['tags']->has($filter_tag);
            });
        }

        // Organize the data to pass to the view.
        $data['groups'] = $groups;
        $data['sum_subscribers'] = Cache::remember('sum_subscribers', $this->cache_time, function () use ($groups) {
            return $groups->sum('subscribers');
        });
        $data['sum_groups'] = Cache::remember('sum_groups', $this->cache_time, function () use ($groups) {
            return $groups->count();
        });
        $data['last_sync'] = $last_sync;
        $data['all_tags'] = $all_tags->sort();
        $data['filter_tag'] = $filter_tag;

        // Show the view.
        return view('home', $data);
    }

    /**
     * Get the content between two params.
     * like, $content = "<b>content</b>"
     * $this->between('<b>', '</b>', $content).
     *
     * @var string
     * @var string $end
     * @var string $content
     *
     * @return string
     */
    protected function between($start, $end, $content)
    {
        return explode($end, explode($start, $content)[1])[0];
    }
}
