// Pusher.logToConsole = true;

var channel = Echo.channel('baseChannel');

channel.listen('.baseContentCreated', function(data){
    $('#contentTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseContentModified', function(data){
    $('#contentTables').DataTable().ajax.reload(null, false);
});