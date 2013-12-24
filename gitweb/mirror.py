import json
import os
import sys
import urllib2
import subprocess

if __name__ == "__main__":
  repositories = json.load(urllib2.urlopen(
      "https://api.github.com/users/damiendart/repos"))
  for repository in repositories:
    os.chdir(os.path.normpath(sys.argv[1]))
    if (os.path.isdir(os.path.basename(repository["git_url"]))):
      os.chdir(os.path.basename(repository["git_url"]))
      subprocess.check_call(["git", "fetch", "--q"]) 
      os.chdir(os.path.normpath(sys.argv[1]))
    else:
      subprocess.check_call(["git", "clone", "--mirror", repository["git_url"]])
    with open(os.path.join(os.path.basename(repository["git_url"]),
        "description"), "w") as f:
      f.write(repository["description"] + "\n")
    with open(os.path.join(os.path.basename(repository["git_url"]), 
        "cloneurl"), "w") as f:
      f.write(repository["clone_url"] + "\n")
