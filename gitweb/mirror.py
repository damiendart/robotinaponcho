#!/usr/bin/env python
"""Maintains mirrors of a GitHub user's public repositories."""

import json
import os
import re
import sys
import urllib2
import subprocess

if __name__ == "__main__":
  if len(sys.argv) != 3:
    sys.stderr.write("Not enough operands\n")
    sys.stderr.write("USAGE: %s GITHUB-USERNAME FOLDER\n" % sys.argv[0])
    sys.exit(1)
  repositories = json.load(urllib2.urlopen(
      "https://api.github.com/users/%s/repos" % sys.argv[1]))
  for repository in repositories:
    os.chdir(os.path.normpath(sys.argv[2]))
    if (os.path.isdir(os.path.basename(repository["git_url"]))):
      os.chdir(os.path.basename(repository["git_url"]))
      subprocess.check_call(["git", "fetch", "-q"])
      os.chdir(os.path.normpath(sys.argv[2]))
    else:
      subprocess.check_call(["git", "clone", "-q", "--mirror",
          repository["git_url"]])
    os.chdir(os.path.basename(repository["git_url"]))
    for k, v in {"url": repository["clone_url"],
        "description": repository["description"],
        "owner": repository["owner"]["login"]}.iteritems():
      subprocess.check_call(["git", "config", "gitweb.%s" % k, v])
    with open("description", "w") as f:
      f.write(repository["description"] + "\n")
