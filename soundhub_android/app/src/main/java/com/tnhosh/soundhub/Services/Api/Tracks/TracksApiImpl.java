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
        list.add(new Track(0, 0, "Middle child", d, 180, "https://muzwave.net/uploads/files/2019-05/1556948728_1-06_-pnb-rock-middle-child-feat_-xxxtentacion.mp3"));
        list.add(new Track(1, 1, "Ball w/o you", d, 180, "https://muzwave.net/uploads/files/2018-12/1545855835_10_-ball-w-o-you.mp3"));
        list.add(new Track(2, 2, "Praise the lord", d, 180, "https://muzwave.net/uploads/files/2018-10/1540835296_aap-rocky-praise-the-lord-da-shine-feat_-skepta.mp3"));
        return list;
    }
}