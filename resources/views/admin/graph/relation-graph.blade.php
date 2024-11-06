<x-app-admin-layout>
    @section('pageTitle', 'User Relationship Chart')
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
                            <select class="user-multiple-sel" id="users" name="users[]" multiple="multiple" style="width:100%;">
                            @if(isset($selectedUsers) && count($selectedUsers) > 0)
                                @foreach($selectedUsers as $user)
                                    <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                @endforeach
                            @endif
                            </select>
                        
                        {{-- @if(isset($groupRelationUsers))
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
                        @endif --}}
                    </div>
                    <div class="card-footer">
                        <div class="row py-2">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark btn waves-effect waves-light inline-flex items-center border rounded-md transition ease-in-out duration-150 mr-4">
                                    Filter
                                </button>
                                <a href="{{route('admin.user-relation-chart')}}">
                                    <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">Reset</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @if(isset($selectedUsers) && count($selectedUsers) > 0)
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                <div class="card-header"><strong>Relationship Chart</strong></div>
                    <div class="card-body">
                        <div id="3d-graph"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                <div class="card-header"><strong>Users Deals Relationship</strong></div>
                    <div class="card-body">
                    <table class="table table-condensed">
                        <tbody>
                        @foreach($grouped as $key=>$row)                            
                                <tr>
                                    <th colspan="2">{{$key}}</th>
                                </tr>
                                @foreach($row->groupBy('preferred_currency') as $currencyKey => $currency_group)
                                <tr>
                                    <td>{{$currencyKey}}</td>
                                    <td>
                                        <table class="table table-condensed">
                                            <tbody> 
                                            @foreach($currency_group as $ckey => $currency)                                           
                                                <tr>
                                                    <td>{{$currency->seller}} -> {{$currency->buyer}}</td>
                                                    <td class="text-end">{{$currency->amount}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <th colspan="2" class="text-end">{{$currency_group->sum('amount')}}</th>
                                                </tr>                                                
                                            </tbody>
                                        </table> 
                                    </td>
                                </tr>
                                @endforeach
                           @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                <div class="card-header"><strong>Users Connectivity</strong></div>
                    <div class="card-body">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Buyer Name</th>
                                <th>Seller Name</th>
                                <th>Operation No</th>
                                <th>Document Type</th>
                                <th>Date time</th>
                                <th>Currency</th>
                                <th>Document Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($userOfferOperations) && count($userOfferOperations) > 0)
                                @foreach($userOfferOperations as $row)
                                <tr>
                                    <td>{{$row->buyer}}</td>
                                    <td>{{$row->seller}}</td>
                                    <td>{{$row->operation_number}}</td>
                                    <td>{{$row->operation_type}}</td>
                                    <td>{{$row->date_time}}</td>
                                    <td>{{$row->preferred_currency}}</td>
                                    <td>{{$row->amount}}</td>
                                    <td><a href="{{route('admin.operations.show',$row->operation_slug)}}" class="text-white btn btn-sm btn-info" target="_blank">Details</a></td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @section('custom_script')
        <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="//unpkg.com/element-resize-detector/dist/element-resize-detector.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
        <script src="https://unpkg.com/3d-force-graph"></script>
        <script src="https://unpkg.com/three-spritetext"></script>
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
                nodes: <?php echo json_encode($nodesDataArr); ?>,
                links: <?php echo json_encode($linksDataArr); ?>
            };

            const graph = ForceGraph3D()(document.getElementById('3d-graph'))
                .height(window.innerHeight - 60)
                .graphData(gData)
                .nodeAutoColorBy('group')
                //.backgroundColor('transparent')
                //.nodeColor(d => d.type=="OK" ? '#4caf50' : '#f44336')
                .linkWidth(1)
                .width(1180)
                .height(300)
                .nodeThreeObject(node => {
                    // Create a text label for the node
                    const labelText = node.id;
                    const label = new SpriteText(labelText);
                    label.material.depthWrite = false;
                    label.color = node.color;
                    label.textHeight = 8;
                    label.position.set(0, 0, 0);
                    const group = new THREE.Group();
                    //group.add(sprite);
                    group.add(label);

                    return group;
                }).linkDirectionalParticles("value").linkDirectionalParticleSpeed(d => d.value * 0.003);;
                graph.d3Force('charge').strength(-120);
            // Graph.d3Force('center', null);

            // // fit to canvas when engine stops
            // Graph.onEngineStop(() => Graph.zoomToFit(1000));
            elementResizeDetectorMaker().listenTo(
            document.getElementById('3d-graph'),
             el => Graph.width(el.offsetWidth)
            );
        </script>
    @endsection
</x-app-admin-layout>
