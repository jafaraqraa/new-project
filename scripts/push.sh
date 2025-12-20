#!/bin/bash
set -e

BRANCH="main"

read -p "Are you sure you want to push changes to '$BRANCH'? (y/n): " choice
if [[ "$choice" != "y" ]]; then
  echo "❌ Push cancelled."
  exit 0
fi

echo "📝 Enter commit message:"
read -r commit_message

if [[ -z "$commit_message" ]]; then
  echo "❌ Commit message cannot be empty."
  exit 1
fi

git status --short
git add .

if git diff --cached --quiet; then
  echo "✅ No changes to commit."
  exit 0
fi

git commit -m "$commit_message"

git pull --rebase origin "$BRANCH"
git push origin "$BRANCH"

echo "✅ Done."
