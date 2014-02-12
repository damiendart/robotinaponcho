// Folder of Crap JavaScript for Damien Dart's personal website.
//
// Copyright (C) 2013, 2014 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

$("td:nth-child(2)").each(function() {
  $(this).text(moment($.trim($(this).text()), "DD-MM-YYYY HH:mm").fromNow());
});
