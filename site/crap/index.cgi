#!/usr/bin/perl -wT

use strict;

use CGI qw/:standard/;
use File::Basename;
use HTML::Template;
use POSIX qw/strftime/;
use URI;

opendir(my $directory, dirname($0)) or die "Unable to open directory.";
my @directory_contents = grep { !/^\.\.?/ && -f } readdir($directory);
@directory_contents = grep { $_ ne basename($0) } @directory_contents;
closedir($directory);
my @table_data;
foreach (@directory_contents) {
  my %row = (filename => $_, 
      modification_date => strftime("%d/%m/%y", localtime((stat($_))[9])),
      size => sprintf("%.1f KB", ((stat($_))[7] / 1024)), uri => URI->new($_));
  $row{size} =~ s/\.0//g;
  push(@table_data, \%row);
}
my $template = HTML::Template->new(filehandle => *DATA);
$template->param(directory_list => \@table_data);
my $output = $template->output;
$output =~ s/^\s+//;
$output =~ s/\n\s*\n/\n/g;
defined $ENV{GATEWAY_INTERFACE} && print header(-charset => "utf-8");
print($output);

__DATA__
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>The Folder of Crap (www.robotinaponcho.net)</title>
    <meta content="noindex,follow" name="robots">
    <link href="/site-assets/crap.css" rel="stylesheet">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0" name="viewport">
  </head>
  <body>
    <h1>The Folder of Crap</h1>
    <p>This folder contains random stuff that I can&#8217;t be bothered
    finding a proper home for. Don&#8217;t expect much.</p>
    <table>
      <thead>
        <tr><th>Filename</th><th>Modification Date</th><th>Size</th></tr>
      </thead>
      <tbody>
        <!-- TMPL_LOOP NAME="directory_list" -->
        <tr><td><a href="<TMPL_VAR NAME="uri">"><TMPL_VAR NAME="filename"></a></td><td><TMPL_VAR NAME="modification_date"></td><td><TMPL_VAR NAME="size"></td></tr>
        <!-- /TMPL_LOOP -->
      </tbody>
    </table>
    <script src="/site-assets/crap.js"></script>
  </body>
</html>
