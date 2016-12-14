@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <div class="alert alert-success text-center">
                <b>Ajude nossa comunidade:</b> Participe das <a href="https://goo.gl/qXN20J">nossas palestras</a><br>
            </div> --}}

            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- vire-um-curador.campuseros.club -->
            <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-6934296242213124"
            data-ad-slot="1378210491"
            data-ad-format="auto"></ins><br />
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center text-uppercase">
                            <b>Total de votos/inscritos</b>
                        </div>
                        <div class="panel-body text-center">
                            <h2>{{ $sum_subscribers }}</h2>
                            <br />
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center text-uppercase">
                            <b>Total de atividades</b>
                        </div>
                        <div class="panel-body text-center">
                            <h2>{{ $sum_activities }}</h2>
                            <br />
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center text-uppercase">
                            <b>última atualização</b>
                            <span class="pull-right"><a href="?update=true" class="btn btn-xs btn-default"><i class="fa fa-refresh"></i></a></span>
                        </div>
                        <div class="panel-body text-center">
                            <h2>{{ $last_sync->format('d/m/Y H:i:s') }}</h2>
                            <small class="muted">timezone: America/Sao_Paulo</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 hidden-xs">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center text-uppercase">
                            <b>Filtre por tags</b>
                        </div>
                        <div class="list-group">
                            @foreach ($all_tags as $slug => $tag)
                                <?php $active = ($filter_tag == $slug); ?>
                                <a class="list-group-item small {{ $active ? 'active' : '' }}" href="{{ $active ? '/' : "?tag=$slug" }}">
                                    {{ $tag['name'] }}
                                    <span class="pull-right badge">{{$tag['amount']}}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center text-uppercase">
                            <b>Classificação</b>
                        </div>

                        <div class="panel-body">
                            <div class="visible-xs">
                                @foreach ($atividades as $atividade)
                                    <div>
                                        <p><h3 class="text-center">{{ $atividade['position'] }}º <br /><small>{{ $atividade['subscribers'] }} inscritos</small></h3></p>
                                        <p class="text-center small">
                                            <a href="{{ $atividade['link'] }}" target="_blank">
                                                {{ $atividade['title'] }}
                                            </a>
                                        </p>
                                        <p class="text-center">
                                            @foreach ($atividade['tags'] as $tag)
                                                <span class="badge"><small>{{ $tag }}</small></span>
                                            @endforeach
                                        </p>
                                        <hr />
                                    </div>
                                @endforeach
                            </div>
                            <div class="table-responsive hidden-xs">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="active">
                                            <th class="text-center text-uppercase" width="5%">Posição</th>
                                            <th class="text-center text-uppercase" width="5%">Inscritos</th>
                                            <th class="text-center text-uppercase" width="45%">Título</th>
                                            <th class="text-center text-uppercase" width="20%">Tags</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($atividades as $atividade)
                                        <tr>
                                            <th class="text-center" style="vertical-align: middle;">{{ $atividade['position'] }}º</th>
                                            <th class="text-center" style="vertical-align: middle;">{{ $atividade['subscribers'] }}</th>
                                            <th class="text-center" style="vertical-align: middle;">
                                                <a href="{{ $atividade['link'] }}" target="_blank">
                                                    {{ $atividade['title'] }}
                                                </a>
                                            </th>
                                            <th class="text-center" style="vertical-align: middle;">
                                                @foreach ($atividade['tags'] as $tag)
                                                    <span class="badge">{{ $tag }}</span>
                                                @endforeach
                                            </th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
