package com.tnhosh.soundhub;

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
import com.tnhosh.soundhub.Services.MusicPlayerService;

public class MainActivity extends AppCompatActivity implements BottomNavigationView.OnNavigationItemSelectedListener {

    Fragment currentFragment;
    Fragment previousFragment;

    MusicPlayerService player = new MusicPlayerService();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        loadFragment(new HomeFragment(), R.id.fragment_container);
        if(isMiniPlayerActive()) {
            loadFragment(new MiniPlayerFragment(), R.id.player_mini_container);
        } else {
            hideMiniPlayer();
        }

        BottomNavigationView navView = findViewById(R.id.nav_view);
        navView.setOnNavigationItemSelectedListener(this);
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
        loadFragment(new PlayerFragment(), R.id.fragment_container);
        hideMiniPlayer();
    }

    public void onMiniPlayerHide(View view) {

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

    private boolean isMiniPlayerActive() {
        return true;
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

    @Override
    public void onDestroy() {
        super.onDestroy();
        player.releaseMP();
    }
}
