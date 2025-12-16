#!/bin/bash
set -e

branch="main"

if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  echo "❌ Not a git repository"
  exit 1
fi

echo "📌 Checking status..."
git status --short

echo "🟢 Adding changes..."
git add .

if git diff --cached --quiet; then
  echo "✅ No changes to commit."
  exit 0
fi

msg="$1"
if [ -z "$msg" ]; then
  echo -n "✍️  Commit message: "
  read -r msg
fi

echo "🧾 Commit: $msg"
git commit -m "$msg"

echo "🚀 Pushing to origin/$branch ..."
git push -u origin "$branch"

echo "✅ Done"
