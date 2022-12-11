<!---
  # This file is distributed under the Creative Commons Attribution 4.0
  # International License. To view a copy of this license, please visit
  # <http://creativecommons.org/licenses/by/4.0/>.

  collections:
    - 'command-line'
    - 'notes'
  twigTemplate: .templates/base-note.html.twig
--->

HTTP Timing Summary with cURL
=============================

This is based on *[Timing Details With cURL][]*.

``` shell
$ curl -o /dev/null -w "time_namelookup:  %{time_namelookup} s
time_connect:       %{time_connect} s
time_appconnect:    %{time_appconnect} s
time_pretransfer:   %{time_pretransfer} s
time_redirect:      %{time_redirect} s
time_starttransfer: %{time_starttransfer} s
time_total:         %{time_total} s
" -s [WEBSITE-URL]
```

  [Timing Details With cURL]: <https://blog.josephscott.org/2011/10/14/timing-details-with-curl/>
