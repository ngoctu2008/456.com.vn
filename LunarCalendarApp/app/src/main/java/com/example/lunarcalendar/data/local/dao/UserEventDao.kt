package com.example.lunarcalendar.data.local.dao

import androidx.room.Dao
import androidx.room.Delete
import androidx.room.Insert
import androidx.room.OnConflictStrategy
import androidx.room.Query
import androidx.room.Update
import com.example.lunarcalendar.data.local.entity.UserEvent
import kotlinx.coroutines.flow.Flow

@Dao
interface UserEventDao {

    @Query("SELECT * FROM user_events WHERE startTime >= :start AND startTime <= :end")
    fun getEventsInRange(start: Long, end: Long): Flow<List<UserEvent>>

    @Query("SELECT * FROM user_events WHERE id = :id")
    suspend fun getEventById(id: Long): UserEvent?

    @Insert(onConflict = OnConflictStrategy.REPLACE)
    suspend fun insertEvent(event: UserEvent)

    @Update
    suspend fun updateEvent(event: UserEvent)

    @Delete
    suspend fun deleteEvent(event: UserEvent)
}
