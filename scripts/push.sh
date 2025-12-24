#!/bin/bash
set -e

BRANCH="main"
# echo "git fetch origin $BRANCH:"
# git fetch origin "$BRANCH"
# git log origin/main
# echo "-----------------------------------"
# echo -e "\033[0;32mGit Push/Pull Script\033[0m"
echo "Choose an action:"
echo "1) Pull (download latest changes)"
echo "2) Push (commit + upload changes)"
echo "3) Pull then Push"
read -p "Enter choice [1-3]: " action

# تأكد إنك على main
current_branch=$(git branch --show-current)
if [[ "$current_branch" != "$BRANCH" ]]; then
  echo "🔁 Switching to $BRANCH"
  git checkout "$BRANCH"
fi

# ---------- PULL ----------
if [[ "$action" == "1" ]]; then
  echo "⬇️ Pulling from origin/$BRANCH"
  git pull origin "$BRANCH"
  exit 0
fi

# ---------- PUSH ----------
if [[ "$action" == "2" ]]; then
  read -p "📝 Enter commit message: " commit_message
  if [[ -z "$commit_message" ]]; then
    echo "❌ Commit message cannot be empty"
    exit 1
  fi

  git add .
  if git diff --cached --quiet; then
    echo "ℹ️ No changes to commit"
    exit 0
  fi

  git commit -m "$commit_message"
  git push origin "$BRANCH"
  exit 0
fi

# ---------- PULL + PUSH ----------
if [[ "$action" == "3" ]]; then
  echo "⬇️ Pulling first..."
  git pull origin "$BRANCH"

  read -p "📝 Enter commit message: " commit_message
  if [[ -z "$commit_message" ]]; then
    echo "❌ Commit message cannot be empty"
    exit 1
  fi

  git add .
  if git diff --cached --quiet; then
    echo "ℹ️ No changes to commit"
    exit 0
  fi

  git commit -m "$commit_message"
  git push origin "$BRANCH"
  exit 0
fi

echo "❌ Invalid choice"
exit 1
