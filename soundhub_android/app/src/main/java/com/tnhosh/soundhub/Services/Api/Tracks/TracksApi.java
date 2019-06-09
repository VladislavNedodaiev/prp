package com.tnhosh.soundhub.Services.Api.Tracks;

import com.tnhosh.soundhub.Models.Track;

import java.util.List;

public interface TracksApi {
    List<Track> getTrackListByPlaylistid(int playListId);
}
