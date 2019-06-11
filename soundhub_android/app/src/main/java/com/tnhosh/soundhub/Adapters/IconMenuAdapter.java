package com.tnhosh.soundhub.Adapters;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.tnhosh.soundhub.R;

import java.util.List;

public class IconMenuAdapter extends RecyclerView.Adapter<IconMenuAdapter.ViewHolder> {

    private LayoutInflater inflater;
    private List<String> items;
    private Context context;

    public IconMenuAdapter(Context context, List<String> items) {
        this.items = items;
        this.inflater = LayoutInflater.from(context);
        this.context = context;
    }

    @Override
    public IconMenuAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.icon_menu_list_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(IconMenuAdapter.ViewHolder holder, int position) {
        String item = items.get(position);
        if (position == 0) {
            holder.itemImage.setImageDrawable(context.getDrawable(R.drawable.lic_ike_filled_gray_24dp));
        } else if (position == 1) {
            holder.itemImage.setImageDrawable(context.getDrawable(R.drawable.ic_playlist_gray_24dp));
        } else if (position == 2) {
            holder.itemImage.setImageDrawable(context.getDrawable(R.drawable.ic_following_gray_24dp));
        }
        holder.itemText.setText(item);
    }

    @Override
    public int getItemCount() {
        return items.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        final TextView itemText;
        final ImageView itemImage;
        ViewHolder(View view){
            super(view);
            itemText = view.findViewById(R.id.icon_menu_item_text);
            itemImage = view.findViewById(R.id.icon_menu_item_image);
        }
    }
}
