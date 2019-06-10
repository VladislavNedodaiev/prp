package com.tnhosh.soundhub.Adapters;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;
import com.tnhosh.soundhub.Models.Track;
import com.tnhosh.soundhub.Models.User;
import com.tnhosh.soundhub.R;
import com.tnhosh.soundhub.Services.Api.Users.UsersApiImpl;
import com.tnhosh.soundhub.Services.MusicPlayerService;

import java.util.List;

public class TrackListAdapter extends RecyclerView.Adapter<TrackListAdapter.ViewHolder>  {

    private LayoutInflater inflater;
    private List<Track> tracks;
    private Context context;
    private MusicPlayerService player;

    //private View.OnClickListener mOnItemClickListener;

    public TrackListAdapter(Context context, List<Track> items, MusicPlayerService playerService) {
        this.player = playerService;
        this.context = context;
        this.tracks = items;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public TrackListAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.track_list_item, parent, false);
        return new TrackListAdapter.ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(TrackListAdapter.ViewHolder holder, final int position) {
        final Track track = tracks.get(position);
        //holder.trackName.setText(track.getName());

        holder.TrackId = track.getId();

        UsersApiImpl uai = new UsersApiImpl();
        User user = uai.getUserById(track.getUserId());
        holder.trackAuthor.setText(user.getLogin());

        holder.trackName.setText(track.getName());

        Picasso.get().load(user.getImageUrl()).into(holder.userImg);
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Track selectedTrack = tracks.get(position);

                if (player.isTrackInPlayer(selectedTrack)) {
                    if (player.isPlaying()) {
                        player.pause();
                    } else {
                        player.play();
                    }
                } else {
                    player.loadTrack(selectedTrack);
                }
            }
        });
    }

    @Override
    public int getItemCount() {
        return tracks.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        ImageView userImg;
        final TextView trackName;
        final TextView trackAuthor;
        public int TrackId = -10;
        ViewHolder(View view){
            super(view);
            userImg = view.findViewById(R.id.track_image);
            trackName = view.findViewById(R.id.track_name);
            trackAuthor = view.findViewById(R.id.author_name);

            view.setTag(this);
        }
    }
}
