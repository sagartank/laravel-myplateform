<div id="connectivityGraph"></div>
@section('custom_script')
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//unpkg.com/force-graph"></script>
    <script>
        const gData = {
            nodes: <?php echo json_encode($nodesDataArr); ?>,
            links: <?php echo json_encode($linksDataArr); ?>
        };

        const Graph = ForceGraph()
        (document.getElementById('connectivityGraph'))
            .linkDirectionalParticles(2)
            .width(500)
            .graphData(gData);
        
        // Graph.d3Force('center', null);

        // // fit to canvas when engine stops
        // Graph.onEngineStop(() => Graph.zoomToFit(1000));
    </script>
@endsection