#!/bin/bash

while true; do

	echo "Press key 1-9 to start radio, or + - for volume"
	# wir speichern die gedrückte taste in der variable $KEY

	read -n1 KEY 

	MPC="mpc -h localhost"

	volume="70"
	commnd=""

	dummy=""

	# play next radio station (=next song in playlist)
	if [ "$KEY" == "/" ];  then	
		dummy=`$MPC next`
		KEY="."
	fi


	if [ "$KEY" == "*" ]; then 
		$MPC stop	
		echo "Pause" | espeak -a 90 -p30 -s120
		read -n1 K2

		$MPC play
	# change volume
	elif [ "$KEY" == "+" ];  then	
		dummy=`$MPC volume +2`
	elif [ "$KEY" == "-" ];  then	
		dummy=`$MPC volume -2`

	# say radio station information
	elif [ "$KEY" == "." ]; then
		va1=`$MPC | sed -n 2p | grep -Poh "#\d+"`
		va2=`$MPC | sed -n 1p | grep -Poh "^[\w\d\s]+"`
		echo "${va1#?} => ${va2}"
		echo "${va1#?}      ${va2}" | espeak -a200
	else 


		# change radio station // song
		if [ "$KEY" -ge 0  ] && [ "$KEY" -le 9  ];  then	
			read -n1 -t1 TKEY

			re='^[0-9]+$'
			if [[ "$TKEY" =~ $re ]]; then
				KEY=$((10*KEY+TKEY))
			fi

			commnd="$MPC play $KEY"

		fi


		if [ "$KEY" == "0" ];  then
			commnd="$MPC"
		fi


		# execute command
		if [ "$commnd" != "" ]; then 
			retrn=`eval ${commnd}` 
			nam=`echo "${retrn}" | sed -n 1p | grep -Poh "^[\w\d\s]+"`
			if [ "$nam" == "http" ]; then 
				nam=`echo "${retrn}" | sed -n 1p | grep -Poh "#[^#]+$"`
				nam=${nam#?}
			fi 
			echo "$KEY => $nam"
			echo "$KEY $nam" | espeak -a150 -p30 -s120

		fi
	fi

done



