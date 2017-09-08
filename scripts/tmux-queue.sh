#!/bin/sh 

tmux source .tmux.conf

tmux new-session -d 'tail -f -n 20 laravel/storage/logs/domain-events.log' 
tmux split-window -h '/usr/bin/zsh'
tmux select-pane -t 0
tmux split-window -v './scripts/start-event-dispatch-queue-worker.sh' -n "Domain Event Dispatch Queue"
tmux split-window -v './scripts/start-standard-queue-worker.sh' -n "Standard Queue"
tmux select-pane -t 3
tmux -2 attach-session -d 
