radio-pi
========

Internetradio stream player shell script for Raspberry Pi

It will "say" the name of the radio station on station change. 


Installation 
============

Step 1: Install Music Player Daemon (MPD) on you raspberry pi
	
	Install MPD:
	http://lesbonscomptes.com/pages/raspmpd.html

	Config of MPD:
	http://www.bobrathbone.com/pi_radio_installation.htm

	MPC (Music player client) man page
	http://linux.die.net/man/1/mpc


Step 2: Copy this repository into the pi user's home dir. Set up the raspberrypi to log in as user "pi" automatically and add radioplayer.sh to .bashrc

	Set up raspberrypi for autologin:
	http://elinux.org/RPi_Debian_Auto_Login

	Then add this to /etc/rc.local:
	su -l pi -c /home/pi/radioplayer.sh


Step 3: Add radio stations and other music sources to MPD playlist
	
	Good list of Radio stations: 
	http://wiki.ubuntuusers.de/Internetradio/Internetradio-Stationen

	Or just use the playlist provided in the repository: 
	First copy the file mpd-playlist.m3u to the mpd playlist directory, you can find the playlist dir path in your mpd.conf.
	Then enter the following commands:
	mpc playlist   # show list of available playlists. if it doesnt show mpd-playlist, you copied it to the wrong path
	mpc clear      # clear current playlist, just in case
	mpc load mpd-playlist    # load playlist



Step 4: Connect a USB keypad (ebay: 10€) and some stereo output, then reboot raspberrypi

	Bingo now you're done. Choose radio stations with numpad. Press 2 numbers within 1 second to jump to 2-digit radio stations. 



Keyboard Controls
=================

Numeric keys: Select radio station 
              (quickly press 2 numbers to jump to 2-digit stations, e.g. press 1 first, and then quickly press 5 to jump to station 15. )

Plus + key:   Increase volume

Minus - key:  Decrease volume

Star * key:   Pause playback

Dot . key:    Repeat station info

Slash / key:  Jump to next station in playlist

