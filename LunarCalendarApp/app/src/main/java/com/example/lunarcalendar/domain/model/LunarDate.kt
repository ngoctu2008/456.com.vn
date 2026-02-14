package com.example.lunarcalendar.domain.model

data class LunarDate(
    val day: Int,
    val month: Int,
    val year: Int,
    val isLeap: Boolean,
    val timeZone: Double = 7.0
) {
    override fun toString(): String {
        return "Day $day/$month/$year" + if (isLeap) " (Leap)" else ""
    }
}
