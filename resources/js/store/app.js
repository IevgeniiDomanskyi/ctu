import { createSlice } from '@reduxjs/toolkit';

export const appSlice = createSlice({
  name: 'app',

  initialState: {
    version: null,
    messages: [],
  },

  reducers: {
    appSetVersion: (state, { payload }) => {
      state.version = payload;
    },

    appSetMessage: (state, { payload }) => {
      state.messages.push(payload);
    },

    appClearMessages: (state) => {
      state.messages = [];
    },
  },
});

export const { appSetVersion, appSetMessage, appClearMessages } = appSlice.actions;

export default appSlice.reducer;