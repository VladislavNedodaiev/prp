package com.tnhosh.soundhub.Services.Api.Playlists;

import com.tnhosh.soundhub.Models.Playlist;

import java.util.List;

public interface PlaylistsApi {
    List<Playlist> getAllPlaylists();
    Playlist getPlaylistById(int id);
}
