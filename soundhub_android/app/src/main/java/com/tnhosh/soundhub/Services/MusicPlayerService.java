package com.tnhosh.soundhub.Services;

import android.app.Activity;
import android.content.Context;
import android.media.AudioAttributes;
import android.media.AudioManager;
import android.media.AudioTrack;
import android.media.MediaPlayer;
import android.net.Uri;

import com.tnhosh.soundhub.Models.Track;
import com.tnhosh.soundhub.R;

import java.io.IOException;

public class MusicPlayerService {

    public final MediaPlayer player = new MediaPlayer();
    boolean isInited = false;
    int currentTrackId = -10;
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
            currentTrackId = track.getId();
    }

    public boolean isTrackInPlayer(Track track) {
        return currentTrackId == track.getId();
    }

    public boolean isPlaying() {
        return player.isPlaying();
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
