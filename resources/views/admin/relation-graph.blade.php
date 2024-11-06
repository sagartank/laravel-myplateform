<x-app-admin-layout>
    @section('custom_style')
        <link href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            div.icon>img {
                max-width: 100%;
                max-height: 100%;
                width: 100%;
                height: auto;
            }
            .users-relation-ul ul {
                padding: 0 0 0 25px;
            }
        </style>
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('User Relationship Chart') }}
            <x-slot name="right">
            </x-slot>
        </x-header>
    </x-slot>

    <div class="container-lg">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><strong>Users</strong></div>
                    <form action="{{route('admin.user-relation-chart')}}" method="post" id="usersForm">
                        @csrf
                    <div class="card-body">
                            <select class="user-multiple-sel" id="users" name="users[]" multiple="multiple" style="width:100%;"></select>
                        
                        @if(isset($groupRelationUsers))
                            @foreach($groupRelationUsers as $key=>$relations)
                            <ul class="users-relation-ul">
                                <li>{{$key}}
                                    <ul>
                                        @foreach($relations as $relation)
                                            <li>{{$relation->buyer}}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            @endforeach
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row py-2">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark btn waves-effect waves-light inline-flex items-center border rounded-md transition ease-in-out duration-150 mr-4">
                                    Filter
                                </button>
                                <a href="http://127.0.0.1:8000/admin/users">
                                    <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">Reset</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                <div class="card-header"><strong>Relationship Chart</strong></div>
                    <div class="card-body">
                        <div id="graph"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header"><strong>Users Connectivity</strong></div>
                    <div class="card-body">
                        <div id="graph"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('custom_script')
        <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="//unpkg.com/force-graph"></script>
        <script type="text/javascript">
            $('.user-multiple-sel').select2({
                placeholder: 'Select an users',
                ajax: {
                    url: "{{route('admin.ajax-user-search')}}",
                    dataType: 'json',
                    delay: 250,
                    minimumInputLength: 3,
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#users').change(function(){
                //$('#usersForm').submit();
            });
        </script>
        <script>
            const gData = {
                nodes: <?php //echo json_encode($nodesDataArr); ?>,
                links: <?php //echo json_encode($linksDataArr); ?>
            };

            const Graph = ForceGraph()
            (document.getElementById('graph'))
                .linkDirectionalParticles(2)
                .width(500)
                .graphData(gData);
            
            // Graph.d3Force('center', null);

            // // fit to canvas when engine stops
            // Graph.onEngineStop(() => Graph.zoomToFit(1000));
        </script>
    @endsection
</x-app-admin-layout>
