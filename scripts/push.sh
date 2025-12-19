#!/bin/bash
set -e

BRANCH="main"

# 0) تأكد--------------- إنك داخل repo
if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  echo "❌ This folder is not a git repository."
  echo "Run: git init"
  exit 1
fi

# 1) تأكد إن في remote اسمه origin
if ! git remote get-url origin >/dev/null 2>&1; then
  echo "❌ Remote 'origin' is not set."
  echo "Add it with: git remote add origin <REPO_URL>"
  exit 1
fi

# 2) تأكد إنك على main
current_branch="$(git branch --show-current)"
if [ "$current_branch" != "$BRANCH" ]; then
  echo "🔁 Switching to $BRANCH ..."
  git checkout "$BRANCH"
fi

echo "📥 2-Way Sync: Pull latest changes from origin/$BRANCH ..."
# لو الريبو جديد وما في upstream، بعمله تلقائي
git pull --rebase origin "$BRANCH" || {
  echo ""
  echo "⚠️ Pull/Rebase failed بسبب تعارض (conflict)."
  echo "افتح VS Code وحل التعارضات ثم:"
  echo "  git add ."
  echo "  git rebase --continue"
  echo "وبعدين شغّل السكربت مرة ثانية."
  exit 1
}

echo "📌 Status:"
git status --short

echo "🧹 Adding changes..."
git add .

# 3) إذا ما في تغييرات
if git diff --cached --quiet; then
  echo "✅ No changes to commit."
  echo "🚀 Nothing to push."
  exit 0
fi

# 4) رسالة الكوميت
msg="$*"
if [ -z "$msg" ]; then
  echo -n "✍️ Commit message: "
  read -r msg
fi

echo "🧾 Commit: $msg"
git commit -m "$msg"

echo "📤 Pushing to origin/$BRANCH ..."
git push -u origin "$BRANCH"

echo "✅ Done: Code synced (pull + commit + push)."
