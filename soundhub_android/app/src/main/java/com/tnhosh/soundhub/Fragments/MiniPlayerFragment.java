package com.tnhosh.soundhub.Fragments;


import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;
import com.tnhosh.soundhub.MainActivity;
import com.tnhosh.soundhub.R;
import com.tnhosh.soundhub.Services.MusicPlayerService;

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
        ImageView playBtn = getView().findViewById(R.id.playPauseButton);
        playBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onPlayPauseClick(v);
            }
        });

        Bundle b = this.getArguments();
        if (b != null) {
            TextView trackName = getView().findViewById(R.id.track_name_mini);
            ImageView trackImg = getView().findViewById(R.id.track_image_mini);
            trackName.setText(b.getString("TrackName"));
            Picasso.get().load(b.getString("ImageUrl")).into(trackImg);
            playBtn.setImageDrawable(getContext().getDrawable(R.drawable.ic_pause));
        }
    }

    public void onPlayPauseClick(View view) {
        MainActivity ma = (MainActivity) getActivity();
        MusicPlayerService player = ma.getMusicPlayerService();
        if (player.isPlaying()) {
            ImageView playBtn = getView().findViewById(R.id.playPauseButton);
            playBtn.setImageDrawable(getContext().getDrawable(R.drawable.ic_play));
            player.pause();
        } else {
            ImageView playBtn = getView().findViewById(R.id.playPauseButton);
            playBtn.setImageDrawable(getContext().getDrawable(R.drawable.ic_pause));
            player.play();
        }
    }

}
