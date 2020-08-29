#!/bin/sh
for i in {1..65536}
do
  echo "port $i"
  php -S localhost:$i -t ./public
  PID=$!
  # Wait for 2 seconds
  sleep 1
  # Kill it
  kill $PID
done


