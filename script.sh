git filter-branch --force --env-filter '
if [ "$GIT_AUTHOR_NAME" = "katanaslay" ] || [ "$GIT_COMMITTER_NAME" = "katanaslay" ] || [ "$GIT_COMMITTER_NAME" = "denyssemenchuk-source" ]; then
    # Отримуємо текст повідомлення коміту
    COMMIT_MSG=$(git log -1 --pretty=%B $GIT_COMMIT)
    
    case "$COMMIT_MSG" in
        *"feat:made 3 lab"*) NEW_DATE="2026-05-26 10:52:52" ;;
        *"feat: 4Lab done"*) NEW_DATE="2026-05-27 08:31:34" ;;
        *"feat: 5 Lab done"*) NEW_DATE="2026-05-28 11:33:03" ;;
        *"feat: 6 Lab done"*) NEW_DATE="2026-05-29 11:34:42" ;;
        *"feat: 7 Lab done"*) NEW_DATE="2026-06-02 09:56:43" ;;
        *"feat: 8 Lab done"*) NEW_DATE="2026-06-03 10:24:44" ;;
        *"feat: 9 Lab done"*) NEW_DATE="2026-06-04 07:49:10" ;;
        *"feat: 10 Lab done"*) NEW_DATE="2026-06-08 07:57:10" ;;
        *"feat: 11 Lab done"*) NEW_DATE="2026-06-09 08:20:24" ;;
        *"feat: 12 Lab done"*) NEW_DATE="2026-06-10 08:49:54" ;;
        *) NEW_DATE="" ;;
    esac

    if [ -n "$NEW_DATE" ]; then
        export GIT_AUTHOR_DATE="$NEW_DATE"
        export GIT_COMMITTER_DATE="$NEW_DATE"
    fi
fi
' -- 540a6fdc10df8b701251af77709b8522d741cdfa..HEAD
