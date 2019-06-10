package com.tnhosh.soundhub.Services;

import android.app.Activity;
import android.content.Context;
import android.media.AudioAttributes;
import android.media.AudioManager;
import android.media.AudioTrack;
import android.media.MediaPlayer;
import android.net.Uri;

import com.tnhosh.soundhub.MainActivity;
import com.tnhosh.soundhub.Models.Track;
import com.tnhosh.soundhub.Services.Api.Users.UsersApi;
import com.tnhosh.soundhub.Services.Api.Users.UsersApiImpl;

import java.io.IOException;

public class MusicPlayerService {

    public final MediaPlayer player = new MediaPlayer();
    boolean isInited = false;
    Track currentTrack = null;
    Context context;

    public MusicPlayerService(Context context) {
        this.context = context;
        initPlayer();
    }

    public void play() {
        if (!player.isPlaying()) {
            player.start();
        }
    }

    public void pause() {
        if (player.isPlaying()) {
            player.pause();
        }
    }

    private void initPlayer() {
        player.reset();

        player.setOnPreparedListener(new MediaPlayer.OnPreparedListener() {
            @Override
            public void onPrepared(MediaPlayer mp) {
                mp.start();
            }
        });

        player.setAudioAttributes(new AudioAttributes.Builder()
                .setUsage(AudioAttributes.USAGE_MEDIA)
                .setContentType(AudioAttributes.CONTENT_TYPE_MUSIC)
                .setLegacyStreamType(AudioManager.STREAM_MUSIC)
                .build());

        isInited = true;
    }

    public void loadTrack(Track track) {
        initPlayer();
            try {
                player.setDataSource(track.getUrl());
            } catch (IOException ex) {
                ex.printStackTrace();
            }
            player.prepareAsync();
            currentTrack = track;

        MainActivity ma = (MainActivity)context;
        UsersApi ua = new UsersApiImpl();
        ma.updateMiniPlayer(ua.getUserById(track.getId()).getImageUrl(), track.getName());
    }

    public boolean isTrackInPlayer(Track track) {
        if (currentTrack == null) {
            return false;
        } else {
            return currentTrack.getId() == track.getId();
        }
    }

    public boolean isPlaying() {
        return player.isPlaying();
    }

    public Track getCurrentTrack() {
        return currentTrack;
    }

    public void seekTo(int position) {
        player.seekTo(position);
    }

    public int getDuration() {
        return player.getDuration();
    }

    public int getCurrentPosition() {
        return player.getCurrentPosition();
    }

    public void releaseMP() {
        try {
            player.release();
        } catch (Exception e) {
            e.printStackTrace();
        }
        isInited = false;
    }
}
