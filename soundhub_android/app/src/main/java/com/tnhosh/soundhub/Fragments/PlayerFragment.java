package com.tnhosh.soundhub.Fragments;

import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.SeekBar;
import android.widget.TextView;

import com.squareup.picasso.Picasso;
import com.tnhosh.soundhub.MainActivity;
import com.tnhosh.soundhub.R;
import com.tnhosh.soundhub.Services.MusicPlayerService;

import java.util.concurrent.TimeUnit;

public class PlayerFragment extends Fragment {

    MainActivity mainActivity = null;
    MusicPlayerService player = null;
    SeekBar mSeekBar;
    private boolean mUserIsSeeking = false;
    TextView trackName;
    TextView authorName;
    ImageView trackImg;
    TextView seekCurrent;
    TextView seekFull;
    ImageView playBtn;
    ImageView hideBtn;
    Button prevBtn;
    Button nextBtn;


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
        player = mainActivity.getMusicPlayerService();

        InitUI();
        final Handler mHandler = new Handler(Looper.getMainLooper());
        //Make sure you update Seekbar on UI thread
        getActivity().runOnUiThread(new Runnable() {

            @Override
            public void run() {
                if(player != null){
                    int currentPos = player.getCurrentPosition();
                    mSeekBar.setProgress(currentPos);
                    seekCurrent.setText(getSeekFormat(currentPos));
                }
                mHandler.postDelayed(this, 1000);
            }
        });
    }

    private void InitUI() {
        playBtn = getView().findViewById(R.id.play_btn_big);
        playBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onPlayPauseClick(v);
            }
        });
        hideBtn = getView().findViewById(R.id.hide_player_big);
        hideBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onHideButtonClick(v);
            }
        });
        nextBtn = getView().findViewById(R.id.next_btn_big);
        nextBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onNextBtn(v);
            }
        });
        prevBtn = getView().findViewById(R.id.prev_btn_big);
        prevBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onPrevBtn(v);
            }
        });

        Bundle b = this.getArguments();
        if (b != null) {
            trackName = getView().findViewById(R.id.track_name_big);
            authorName = getView().findViewById(R.id.author_name_big);
            trackImg = getView().findViewById(R.id.track_image_big);
            seekCurrent = getView().findViewById(R.id.seek_current);
            seekFull = getView().findViewById(R.id.seek_full);


            mSeekBar = getView().findViewById(R.id.audio_seek);
            initSeekBar();

            trackName.setText(b.getString("TrackName"));
            authorName.setText(b.getString("AuthorName"));
            Picasso.get().load(b.getString("ImageUrl")).resize(1000, 1000).into(trackImg);
            seekCurrent.setText(getSeekFormat(b.getInt("SeekPosition")));
            seekFull.setText(getSeekFormat(b.getInt("SeekFull")));

            mSeekBar.setMax(b.getInt("SeekFull"));
            mSeekBar.setProgress(b.getInt("SeekPosition"));

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
        mainActivity.onPlayerHide(view);
    }

    private void initSeekBar() {
        mSeekBar.setOnSeekBarChangeListener(
            new SeekBar.OnSeekBarChangeListener() {
                int userSelectedPosition = 0;

                @Override
                public void onStartTrackingTouch(SeekBar seekBar) {
                    mUserIsSeeking = true;
                }

                @Override
                public void onProgressChanged(SeekBar seekBar, int progress, boolean fromUser) {
                    if (fromUser) {
                        userSelectedPosition = progress;
                    }
                }

                @Override
                public void onStopTrackingTouch(SeekBar seekBar) {
                    mUserIsSeeking = false;
                    player.seekTo(userSelectedPosition);
                    seekCurrent.setText(getSeekFormat(userSelectedPosition));
                }
            });
    }

    private String getSeekFormat(int msec) {
        long a = TimeUnit.MILLISECONDS.toSeconds(msec);
        long mins = a / 60;
        long secs = a - (mins * 60);
        String secsStr = String.valueOf(secs);
        return mins + ":" + (secsStr.length() == 1 ? "0" + secsStr : secsStr);
    }

    private void onNextBtn(View view) {

    }

    private void onPrevBtn(View view) {

    }
}
