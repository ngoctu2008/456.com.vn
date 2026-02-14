package com.example.lunarcalendar.presentation.daily

import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.lunarcalendar.core.utils.LunarDateConverter
import com.example.lunarcalendar.domain.model.LunarDate
import dagger.hilt.android.lifecycle.HiltViewModel
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import kotlinx.coroutines.launch
import java.time.LocalDate
import javax.inject.Inject

data class DailyCalendarState(
    val date: LocalDate = LocalDate.now(),
    val lunarDate: LunarDate? = null,
    val solarTerm: String = "",
    val zodiacHour: String = ""
)

@HiltViewModel
class DailyCalendarViewModel @Inject constructor() : ViewModel() {

    private val _state = MutableStateFlow(DailyCalendarState())
    val state: StateFlow<DailyCalendarState> = _state.asStateFlow()

    init {
        loadDataForDate(LocalDate.now())
    }

    fun onDateSelected(date: LocalDate) {
        loadDataForDate(date)
    }

    private fun loadDataForDate(date: LocalDate) {
        viewModelScope.launch {
            val lunar = LunarDateConverter.convertSolarToLunar(date.dayOfMonth, date.monthValue, date.year)
            val term = LunarDateConverter.getSolarTerm(date.dayOfMonth, date.monthValue, date.year)
            val zodiac = LunarDateConverter.getZodiacHour(lunar.month, lunar.day)

            _state.value = _state.value.copy(
                date = date,
                lunarDate = lunar,
                solarTerm = term,
                zodiacHour = zodiac
            )
        }
    }
}
