#!/bin/bash

read -p "Are you sure you want to push changes to the repository? (y/n): " choice
if [[ "$choice" != "y" ]]; then
    echo "Push operation cancelled."
    exit 0
fi

echo entering message commit  
read commit_message

  

git add .
git commit -m "$commit_message"
git push origin main  
