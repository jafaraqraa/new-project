#!/bin/bash

read -p "Are you sure you want to push changes to the repository? (y/n): " choice
if [[ "$choice" != "y" ]]; then
    echo "Push operation cancelled."
    exit 0
fi



git add .
git commit -m "Auto commit"
git push origin main  
