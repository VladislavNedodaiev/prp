package com.tnhosh.soundhub.Models;

import java.util.Date;

public class Playlist {
    private int Id;
    private int UserId;
    private String Name;
    private Date UpdateDate;
    private Date ReleaseDate;
    private String Description;

    public Playlist(int id, int userId, String name, Date updateDate, Date releaseDate, String description, String imageUrl) {
        Id = id;
        UserId = userId;
        Name = name;
        UpdateDate = updateDate;
        ReleaseDate = releaseDate;
        Description = description;
        ImageUrl = imageUrl;
    }

    public int getId() {
        return Id;
    }

    public void setId(int id) {
        Id = id;
    }

    public int getUserId() {
        return UserId;
    }

    public void setUserId(int userId) {
        this.UserId = userId;
    }

    public String getName() {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }

    public Date getUpdateDate() {
        return UpdateDate;
    }

    public void setUpdateDate(Date updateDate) {
        UpdateDate = updateDate;
    }

    public Date getReleaseDate() {
        return ReleaseDate;
    }

    public void setReleaseDate(Date releaseDate) {
        ReleaseDate = releaseDate;
    }

    public String getDescription() {
        return Description;
    }

    public void setDescription(String description) {
        Description = description;
    }

    public String getImageUrl() {
        return ImageUrl;
    }

    public void setImageUrl(String imageUrl) {
        ImageUrl = imageUrl;
    }

    public String ImageUrl;
}
