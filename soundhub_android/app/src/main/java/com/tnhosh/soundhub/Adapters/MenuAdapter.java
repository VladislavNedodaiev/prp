package com.tnhosh.soundhub.Adapters;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.tnhosh.soundhub.R;

import java.util.List;

public class MenuAdapter extends RecyclerView.Adapter<MenuAdapter.ViewHolder> {

    private LayoutInflater inflater;
    private List<String> items;

    public MenuAdapter(Context context, List<String> items) {
        this.items = items;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public MenuAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.library_list_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MenuAdapter.ViewHolder holder, int position) {
        String item = items.get(position);
        if (position == 0) {
            holder.topDivider.setVisibility(View.GONE);
        } else if (position == getItemCount() - 1) {
            holder.botDivider.setVisibility(View.GONE);
        }
        holder.nameView.setText(item);
    }

    @Override
    public int getItemCount() {
        return items.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        final TextView nameView;
        final View topDivider;
        final View botDivider;
        ViewHolder(View view){
            super(view);
            nameView = view.findViewById(R.id.item_name);
            topDivider = view.findViewById(R.id.top_divider);
            botDivider = view.findViewById(R.id.bot_divider);
        }
    }
}
