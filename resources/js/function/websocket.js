Pusher.logToConsole = true;

var channel = Echo.channel('baseChannel');

channel.listen('.baseContentCreated', function(data){
    $('#contentTables').DataTable().ajax.reload();
});

channel.listen('.baseContentModified', function(data){
    $('#contentTables').DataTable().ajax.reload();
});