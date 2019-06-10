package com.tnhosh.soundhub.Fragments;


import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.tnhosh.soundhub.Models.Track;
import com.tnhosh.soundhub.R;
import com.tnhosh.soundhub.Services.MusicPlayerService;

import java.util.Date;

public class MiniPlayerFragment extends Fragment {


    public MiniPlayerFragment() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_mini_player, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        ImageView playBtn = getView().findViewById(R.id.imageView3);
        playBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onPlayClick(v);
            }
        });
    }

    final String AUDIO_URL = "https://muzwave.net/uploads/files/2019-05/1556948728_1-06_-pnb-rock-middle-child-feat_-xxxtentacion.mp3";

    public void onPlayClick(View view) {
        ImageView playBtn = getView().findViewById(R.id.imageView3);
        playBtn.setImageDrawable(getContext().getDrawable(R.drawable.ic_pause));

        MusicPlayerService player = new MusicPlayerService(getActivity());
        player.loadTrack(new Track(10, 0, "", new Date(324243242), 180, AUDIO_URL));
    }

}
