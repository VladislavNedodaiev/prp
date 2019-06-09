package com.tnhosh.soundhub.Adapters;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.tnhosh.soundhub.Models.Track;
import com.tnhosh.soundhub.R;

import java.util.List;

public class TrackListAdapter extends RecyclerView.Adapter<TrackListAdapter.ViewHolder>  {

    private LayoutInflater inflater;
    private List<Track> tracks;
    private Context context;

    public TrackListAdapter(Context context, List<Track> items) {
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
    public void onBindViewHolder(TrackListAdapter.ViewHolder holder, int position) {
        Track track = tracks.get(position);
        //holder.trackName.setText(track.getName());

        // TODO: loading author name from api by track.getUserId();
        holder.trackAuthor.setText("XXXTentacion");
        //TODO: Image loading from api by track.getImageUrl();
        holder.trackImage.setImageDrawable(context.getDrawable(R.drawable.headphones_logo));
    }

    @Override
    public int getItemCount() {
        return tracks.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        final ImageView trackImage;
        final TextView trackName;
        final TextView trackAuthor;
        ViewHolder(View view){
            super(view);
            trackImage = view.findViewById(R.id.track_image);
            trackName = view.findViewById(R.id.track_name);
            trackAuthor = view.findViewById(R.id.author_name);
        }
    }
}
