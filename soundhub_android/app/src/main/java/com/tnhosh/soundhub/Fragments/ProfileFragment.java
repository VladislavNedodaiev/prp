package com.tnhosh.soundhub.Fragments;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import com.tnhosh.soundhub.Adapters.MenuAdapter;
import com.tnhosh.soundhub.LaunchActivity;
import com.tnhosh.soundhub.R;

import java.util.ArrayList;
import java.util.List;

import static android.content.Context.MODE_PRIVATE;

public class ProfileFragment extends Fragment {

    List<String> menuItems = new ArrayList<>();
    List<String> subscrMenuItems = new ArrayList<>();
    Button signInBtn;

    public ProfileFragment() {
        // Required empty public constructor
    }

    public static ProfileFragment newInstance(String param1, String param2) {
        ProfileFragment fragment = new ProfileFragment();
        Bundle args = new Bundle();
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_profile, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        setInitialData();
        RecyclerView rw = getView().findViewById(R.id.profile_menu_list);
        rw.setLayoutManager(new LinearLayoutManager(getActivity()));
        MenuAdapter adapter = new MenuAdapter( getActivity(), menuItems);
        rw.setAdapter(adapter);

        RecyclerView rw1 = getView().findViewById(R.id.subscribe_menu_list);
        rw1.setLayoutManager(new LinearLayoutManager(getActivity()));
        MenuAdapter adapter1 = new MenuAdapter( getActivity(), subscrMenuItems);
        rw1.setAdapter(adapter1);

        signInBtn = getActivity().findViewById(R.id.sign_out_btn);
        signInBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onSignOut(v);
            }
        });
    }

    private void setInitialData() {
        menuItems.add("Change your e-mail");
        menuItems.add("Change your password");
        subscrMenuItems.add("Subscribe to Soundhub Premium");
    }

    public void onSignOut(View view) {
        SharedPreferences settings = getActivity().getSharedPreferences("Account", MODE_PRIVATE);
        SharedPreferences.Editor prefEditor = settings.edit();
        prefEditor.clear().apply();
        Intent intent = new Intent(getActivity(), LaunchActivity.class);
        getActivity().finish();
        startActivity(intent);
    }
}
