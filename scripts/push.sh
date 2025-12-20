#!/bin/bash




read -p "Enter your Git username: " git_username
git config --global user.name "$git_username"
read -p "Enter your Git email: " git_email
git config --global user.email "$git_email"
echo "Git user configured as $git_username <$git_email>"

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
