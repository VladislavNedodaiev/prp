package com.tnhosh.soundhub.Services.Api.Playlists;

import com.tnhosh.soundhub.Models.Playlist;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

public class PlaylistsApiImpl implements PlaylistsApi{
    @Override
    public List<Playlist> getAllPlaylists() {
        Date d = Calendar.getInstance().getTime();
        List<Playlist> list = new ArrayList<>();
        list.add(new Playlist(0, 0, "Newly posted", d, d, "", ""));
        list.add(new Playlist(1, 1, "Most popular", d, d, "", ""));
        return list;
    }

    @Override
    public Playlist getPlaylistById(int id) {
        Date d = Calendar.getInstance().getTime();
        if (id == 0) {
            return new Playlist(0, 0, "Newly posted", d, d, "", "");
        } else if (id == 1) {
            return new Playlist(1, 1, "Most popular", d, d, "", "");
        }
        return null;
    }

    @Override
    public Playlist getPlaylistByTrackId(int trackId) {
        return getPlaylistById(0);
    }


}
