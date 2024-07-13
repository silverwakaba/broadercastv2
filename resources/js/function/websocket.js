Pusher.logToConsole = true;

var channel = Echo.channel('baseChannel');

channel.listen('.baseContentCreated', function(data){
    $('#contentTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseContentModified', function(data){
    $('#contentTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseGenderCreated', function(data){
    $('#genderTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseGenderModified', function(data){
    $('#genderTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseLanguageCreated', function(data){
    $('#languageTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseLanguageModified', function(data){
    $('#languageTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseLinkCreated', function(data){
    $('#linkTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseLinkModified', function(data){
    $('#linkTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseRaceCreated', function(data){
    $('#raceTables').DataTable().ajax.reload(null, false);
});

channel.listen('.baseRaceModified', function(data){
    $('#raceTables').DataTable().ajax.reload(null, false);
});