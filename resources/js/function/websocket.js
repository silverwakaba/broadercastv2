Pusher.logToConsole = true;

// Base Channel
var baseChannel = Echo.channel('baseChannel');

baseChannel.listen('.baseContentCreated', function(data){
    $('#contentTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseContentModified', function(data){
    $('#contentTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseGenderCreated', function(data){
    $('#genderTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseGenderModified', function(data){
    $('#genderTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseLanguageCreated', function(data){
    $('#languageTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseLanguageModified', function(data){
    $('#languageTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseLinkCreated', function(data){
    $('#linkTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseLinkModified', function(data){
    $('#linkTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseRaceCreated', function(data){
    $('#raceTables').DataTable().ajax.reload(null, false);
});

baseChannel.listen('.baseRaceModified', function(data){
    $('#raceTables').DataTable().ajax.reload(null, false);
});

// Users Channel
var usersChannel = Echo.channel('usersChannel');

usersChannel.listen('.usersCreated', function(data){
    $('#userTables').DataTable().ajax.reload(null, false);
});

usersChannel.listen('.UserModified', function(data){
    $('#userTables').DataTable().ajax.reload(null, false);
});