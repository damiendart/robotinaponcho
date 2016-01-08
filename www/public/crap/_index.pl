#!/usr/bin/perl -wT
# Folder of Crap CGI script for Damien Dart's personal website.
#
# Copyright (C) 2013-2016 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

use strict;

use CGI qw/:standard/;
use File::Basename;
use HTML::Template;
use PerlIO::gzip;
use POSIX qw/strftime/;
use URI;

opendir(my $directory, dirname($0)) or die "Unable to open directory.";
my @directory_contents = grep { !/^\.\.?/ && -f } readdir($directory);
@directory_contents = grep { $_ ne basename($0) } @directory_contents;
closedir($directory);
my @table_data;
foreach (@directory_contents) {
  my %row = (filename => $_,
      modification_date => strftime("%F %T %z", localtime((stat($_))[9])),
      size => sprintf("%.1f KB", ((stat($_))[7] / 1024)),
      timestamp => (stat($_))[9], uri => URI->new($_));
  $row{size} =~ s/\.0//g;
  push(@table_data, \%row);
}
my $template = HTML::Template->new(filehandle => *DATA);
$template->param(directory_list => \@table_data);
my $output = $template->output;
$output =~ s/^\s+//;
$output =~ s/\n\s*\n/\n/g;
my %content_encoding = ();
if ($ENV{HTTP_ACCEPT_ENCODING} &&
    $ENV{HTTP_ACCEPT_ENCODING} =~ m/(^|,|;|\s)gzip(,|;|\s|$)/ &&
    $ENV{HTTP_ACCEPT_ENCODING} !~ m/(^|,|;|\s)gzip\s*;q=0(,|\s|$)/) {
  %content_encoding = (-content_encoding => "gzip");
}
print header(%content_encoding, -charset => "utf-8");
binmode STDOUT, ":gzip" if (%content_encoding);
print($output);


__DATA__
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<title>The Folder of Crap Test</title>
<table>
  <thead>
    <tr><th>Filename</th><th>Modification Date</th><th>Size</th></tr>
  </thead>
  <tbody>
    <!-- TMPL_LOOP NAME="directory_list" -->
    <tr><td><a href="<TMPL_VAR NAME="uri">"><TMPL_VAR NAME="filename"></a></td><td><TMPL_VAR NAME="modification_date"> (<TMPL_VAR NAME="timestamp">)</td><td><TMPL_VAR NAME="size"></td></tr>
    <!-- /TMPL_LOOP -->
  </tbody>
</table>
