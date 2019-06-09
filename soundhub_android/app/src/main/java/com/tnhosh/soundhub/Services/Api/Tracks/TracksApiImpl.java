package com.tnhosh.soundhub.Services.Api.Tracks;

import com.tnhosh.soundhub.Models.Track;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

public class TracksApiImpl implements TracksApi {
    @Override
    public List<Track> getTrackListByPlaylistid(int playListId) {
        List<Track> list = new ArrayList<>();
        Date d = Calendar.getInstance().getTime();
        list.add(new Track(0, 0, "Moonlight", d, 180));
        list.add(new Track(0, 1, "Middle child", d, 180));
        list.add(new Track(0, 0, "SAD", d, 180));
        return list;
    }
}