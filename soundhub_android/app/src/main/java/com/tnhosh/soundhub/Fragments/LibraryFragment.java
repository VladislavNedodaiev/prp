package com.tnhosh.soundhub.Fragments;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.tnhosh.soundhub.Adapters.IconMenuAdapter;
import com.tnhosh.soundhub.Adapters.MenuAdapter;
import com.tnhosh.soundhub.R;

import java.util.ArrayList;
import java.util.List;

public class LibraryFragment extends Fragment {

    public List<String> menuItems = new ArrayList<>();

    public LibraryFragment() {
    }

    // TODO: Rename and change types and number of parameters
    public static LibraryFragment newInstance() {
        LibraryFragment fragment = new LibraryFragment();
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
        return inflater.inflate(R.layout.fragment_library, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        setInitialData();
        RecyclerView rw = getView().findViewById(R.id.library_menu_list);
        rw.setLayoutManager(new LinearLayoutManager(getActivity()));
        IconMenuAdapter adapter = new IconMenuAdapter(getActivity(), menuItems);
        rw.setAdapter(adapter);
    }

    private void setInitialData() {
        menuItems.add("Likes");
        menuItems.add("Playlists");
        menuItems.add("Following");
    }

}
