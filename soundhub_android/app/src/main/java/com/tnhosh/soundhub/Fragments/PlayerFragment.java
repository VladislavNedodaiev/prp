package com.tnhosh.soundhub.Fragments;

import android.content.Context;
import android.net.Uri;
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

public class PlayerFragment extends Fragment {

    MainActivity mainActivity = null;
    MusicPlayerService player = null;

    public PlayerFragment() {
        // Required empty public constructor
    }

    public static PlayerFragment newInstance() {
        PlayerFragment fragment = new PlayerFragment();
        Bundle args = new Bundle();
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_player, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        mainActivity = (MainActivity) getActivity();

        ImageView playBtn = getView().findViewById(R.id.play_btn_big);
        playBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onPlayPauseClick(v);
            }
        });
        ImageView hideBtn = getView().findViewById(R.id.hide_player_big);
        hideBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onHideButtonClick(v);
            }
        });

        Bundle b = this.getArguments();
        if (b != null) {
            TextView trackName = getView().findViewById(R.id.track_name_big);
            TextView authorName = getView().findViewById(R.id.author_name_big);
            ImageView trackImg = getView().findViewById(R.id.track_image_big);
            TextView seekCurrent = getView().findViewById(R.id.seek_current);
            TextView seekFull = getView().findViewById(R.id.seek_full);


            trackName.setText(b.getString("TrackName"));
            authorName.setText(b.getString("AuthorName"));
            Picasso.get().load(b.getString("ImageUrl")).resize(1000, 1000).into(trackImg);
            seekCurrent.setText(String.valueOf(b.getInt("SeekPosition")));
            seekFull.setText(String.valueOf(b.getInt("SeekFull")));

            playBtn.setImageDrawable(getContext().getDrawable(R.drawable.ic_pause));
        }
    }

    public void onPlayPauseClick(View view) {
        player = mainActivity.getMusicPlayerService();
        if (player.isPlaying()) {
            ImageView playBtn = getView().findViewById(R.id.play_btn_big);
            playBtn.setImageDrawable(getContext().getDrawable(R.drawable.ic_play));
            player.pause();
        } else {
            ImageView playBtn = getView().findViewById(R.id.play_btn_big);
            playBtn.setImageDrawable(getContext().getDrawable(R.drawable.ic_pause));
            player.play();
        }
    }

    public void onHideButtonClick(View view) {
        //mainActivity.loadFragment(mainActivity.previousFragment, R.id.fragment_container);
        mainActivity.onPlayerHide(view);
    }
}
