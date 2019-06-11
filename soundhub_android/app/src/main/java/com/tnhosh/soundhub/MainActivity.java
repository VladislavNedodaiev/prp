package com.tnhosh.soundhub;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.app.Fragment;
import android.support.v7.app.AppCompatActivity;
import android.support.annotation.NonNull;
import android.view.MenuItem;
import android.view.View;

import com.tnhosh.soundhub.Fragments.HomeFragment;
import com.tnhosh.soundhub.Fragments.LibraryFragment;
import com.tnhosh.soundhub.Fragments.MiniPlayerFragment;
import com.tnhosh.soundhub.Fragments.PlayerFragment;
import com.tnhosh.soundhub.Fragments.ProfileFragment;
import com.tnhosh.soundhub.Models.Track;
import com.tnhosh.soundhub.Models.User;
import com.tnhosh.soundhub.Services.Api.Fingerprint.FingerprintApi;
import com.tnhosh.soundhub.Services.Api.Users.UsersApiImpl;
import com.tnhosh.soundhub.Services.MusicPlayerService;

import java.io.ObjectStreamClass;
import java.io.Serializable;

public class MainActivity extends AppCompatActivity implements BottomNavigationView.OnNavigationItemSelectedListener {

    Fragment currentFragment;
    Fragment previousFragment;
    private FingerprintApi api;

    MusicPlayerService player = new MusicPlayerService(this);

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if(isMiniPlayerActive()) {
            loadFragment(new MiniPlayerFragment(), R.id.player_mini_container);
        } else {
            hideMiniPlayer();
        }
        loadFragment(new HomeFragment(), R.id.fragment_container);

        BottomNavigationView navView = findViewById(R.id.nav_view);
        navView.setOnNavigationItemSelectedListener(this);

        View miniPlayer = findViewById(R.id.player_mini_container);
        miniPlayer.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onMiniPlayerClick(v);
            }
        });
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;

        switch (item.getItemId()) {
            case R.id.navigation_home:
                fragment = new HomeFragment();
                break;
            case R.id.navigation_library:
                fragment = new LibraryFragment();
                break;
            case R.id.navigation_profile:
                if (hasFingerPrint()) {
                    Intent intent = new Intent(this, FingerprintActivity.class);
                    startActivity(intent);
                }
                fragment = new ProfileFragment();
                break;
        }

        if (currentFragment.getClass() == PlayerFragment.class) {
            showMiniPlayer();
        }
        return loadFragment(fragment, R.id.fragment_container);
    }

    public void onMiniPlayerClick(View view) {
        previousFragment = currentFragment;
        //loadFragment(new PlayerFragment(), R.id.fragment_container);
        Track currTrack = player.getCurrentTrack();
        User currUser = UsersApiImpl.getInstance().getUserById(currTrack.getUserId());
        loadPlayer(currUser.getImageUrl(), currTrack.getName(), currUser.getLogin(), player.getCurrentPosition(), player.getDuration());
        hideMiniPlayer();
        currentFragment = new PlayerFragment();
    }

    public void onPlayerHide(View view) {
        loadFragment(previousFragment, R.id.fragment_container);
        showMiniPlayer();
    }


    private boolean loadFragment(Fragment fragment, int containter) {
        if (fragment != null) {
            getSupportFragmentManager()
                    .beginTransaction()
                    .replace(containter, fragment)
                    .commit();
            currentFragment = fragment;
            return true;
        }
        return false;
    }

    private boolean isFingerprintSupported() {
        // Check for availability and any additional requirements for the api.
        return (api = FingerprintApi.create(this)) != null && api.isFingerprintSupported();
    }

    public void updateMiniPlayer(String ImageUrl, String TrackName) {
        MiniPlayerFragment mpFrag = new MiniPlayerFragment();
        Bundle bundle = new Bundle();
        bundle.putString("ImageUrl", ImageUrl);
        bundle.putString("TrackName", TrackName);
        mpFrag.setArguments(bundle);
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.player_mini_container, mpFrag)
                .commit();
        showMiniPlayer();
    }

    public void loadProfileFragment(Fragment fragment) {
        if (fragment != null) {
            getSupportFragmentManager()
                    .beginTransaction()
                    .replace(R.id.fragment_container, fragment)
                    .commit();
            currentFragment = fragment;
        }
    }

    public void loadPlayer(String imageUrl, String trackName, String authorName, int seekPosition, int seekFull) {
        PlayerFragment pFrag = new PlayerFragment();
        Bundle bundle = new Bundle();
        bundle.putString("ImageUrl", imageUrl);
        bundle.putString("TrackName", trackName);
        bundle.putString("AuthorName", authorName);
        bundle.putInt("SeekPosition", seekPosition);
        bundle.putInt("SeekFull", seekFull);
        pFrag.setArguments(bundle);
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, pFrag)
                .commit();
    }

    private boolean isMiniPlayerActive() {
        return false;
    }

    public MusicPlayerService getMusicPlayerService() {
        return player;
    }

    private void hideMiniPlayer() {
        View mpFrag = findViewById(R.id.player_mini_container);
        mpFrag.setVisibility(View.GONE);
    }

    private void showMiniPlayer() {
        View mpFrag = findViewById(R.id.player_mini_container);
        mpFrag.setVisibility(View.VISIBLE);
    }

    private boolean hasProfileAccess() {
        return false;
    }

    private boolean hasFingerPrint() {
        SharedPreferences settings = getSharedPreferences("Account", MODE_PRIVATE);
        boolean b = settings.getBoolean("HasFingerprint", false);
        return b;
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        player.releaseMP();
    }


}
