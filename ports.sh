#!/bin/sh
for i in {1..65536}
do
  # echo "port $i"
  php -S localhost:$i -t ./public
  PID=$!

  sleep 0.1
  # Kill it
  kill $PID
done

# sh ports.sh 2>&1 | tee ports.log