package com.tnhosh.soundhub.Fragments;

import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.tnhosh.soundhub.Adapters.LibraryMenuAdapter;
import com.tnhosh.soundhub.Adapters.TrackListAdapter;
import com.tnhosh.soundhub.Models.Playlist;
import com.tnhosh.soundhub.Models.Track;
import com.tnhosh.soundhub.R;
import com.tnhosh.soundhub.Services.Api.Playlists.PlaylistsApi;
import com.tnhosh.soundhub.Services.Api.Playlists.PlaylistsApiImpl;
import com.tnhosh.soundhub.Services.Api.Tracks.TracksApi;
import com.tnhosh.soundhub.Services.Api.Tracks.TracksApiImpl;

import java.util.ArrayList;
import java.util.List;

public class HomeFragment extends Fragment {

    PlaylistsApiImpl pai = new PlaylistsApiImpl();
    TracksApiImpl tai = new TracksApiImpl();
    Playlist playlist;
    List<Track> tracks = new ArrayList<>();
    Playlist playlist1;
    List<Track> tracks1 = new ArrayList<>();

    public HomeFragment() {
        // Required empty public constructor
    }

    public static HomeFragment newInstance() {
        HomeFragment fragment = new HomeFragment();
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
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_home, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        setInitialData();
        RecyclerView rw = getView().findViewById(R.id.newly_posted_list);
        rw.setLayoutManager(new LinearLayoutManager(getActivity()));
        TrackListAdapter adapter = new TrackListAdapter(getActivity(), tracks);
        rw.setAdapter(adapter);

        RecyclerView rw1 = getView().findViewById(R.id.most_popular_list);
        rw1.setLayoutManager(new LinearLayoutManager(getActivity()));
        TrackListAdapter adapter1 = new TrackListAdapter(getActivity(), tracks1);
        rw1.setAdapter(adapter1);
    }

    private void setInitialData() {
        playlist = pai.getPlaylistById(0);
        tracks = tai.getTrackListByPlaylistid(playlist.getId());
        playlist1 = pai.getPlaylistById(1);
        tracks1 = tai.getTrackListByPlaylistid(playlist1.getId());
    }
}
