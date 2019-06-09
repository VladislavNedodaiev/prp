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

public class LibraryMenuAdapter extends RecyclerView.Adapter<LibraryMenuAdapter.ViewHolder> {

    private LayoutInflater inflater;
    private List<String> items;

    public LibraryMenuAdapter(Context context, List<String> items) {
        this.items = items;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public LibraryMenuAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.library_list_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(LibraryMenuAdapter.ViewHolder holder, int position) {
        String item = items.get(position);
        holder.nameView.setText(item);
    }

    @Override
    public int getItemCount() {
        return items.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        final TextView nameView;
        ViewHolder(View view){
            super(view);
            nameView = view.findViewById(R.id.item_name);
        }
    }
}
