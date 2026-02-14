package com.example.lunarcalendar.data.local.entity

import androidx.room.Entity
import androidx.room.PrimaryKey

@Entity(tableName = "user_events")
data class UserEvent(
    @PrimaryKey(autoGenerate = true)
    val id: Long = 0,
    val title: String,
    val description: String?,
    val startTime: Long, // Epoch millis
    val endTime: Long,
    val isLunar: Boolean = false, // If the event repeats based on Lunar date
    val repeatMode: RepeatMode = RepeatMode.NONE
)

enum class RepeatMode {
    NONE, DAILY, WEEKLY, MONTHLY, YEARLY
}
