#!/usr/bin/perl -wT
# Homepage CGI script for Damien Dart's personal website.
#
# Copyright (C) 2013-2015 Damien Dart, <damiendart@pobox.com>.
# This file is distributed under the MIT licence. For more information,
# please refer to the accompanying "LICENCE" file.

use strict;

use CGI qw/:standard/;
use File::Basename;
use HTML::Template;

opendir(my $directory, "./art/") or die "Unable to open directory: $!";
my @images = grep { ! /^\./ } readdir($directory);
closedir($directory);
my @artwork;
foreach (reverse(@images)) {
  my %art = (filename => $_);
  push(@artwork, \%art);
}
my $template = HTML::Template->new(filehandle => *DATA);
$template->param(artwork => \@artwork);
my $output = $template->output;
$output =~ s/^\s+//;
$output =~ s/\n\s*\n/\n/g;
defined $ENV{GATEWAY_INTERFACE} && print header(-charset => "utf-8");
print($output);

__DATA__
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<title>Art Stuff Test</title>
<!-- TMPL_LOOP NAME="artwork" -->
  <img src="/art/<TMPL_VAR NAME="filename">">
<!-- /TMPL_LOOP -->
