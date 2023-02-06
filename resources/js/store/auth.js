import Cookies from 'universal-cookie';
import { createSlice } from '@reduxjs/toolkit';
import { request } from './index';

const cookies = new Cookies();

export const adminLogin = request('admin/login', 'POST');
export const adminLogout = request('admin/logout', 'DELETE');
export const adminMe = request('admin/me');

export const userLogin = request('api/login', 'POST');
export const userLogout = request('api/logout', 'DELETE');
export const userMe = request('api/me');

export const authSlice = createSlice({
  name: 'auth',

  initialState: {
    me: {},
    isLoggedIn: false,
    hasNoAccess: false,
  },

  reducers: {
    adminIsLoggedIn: (state) => {
      const token = cookies.get('admin-token');
      if (token) {
        state.isLoggedIn = true;
      }
    },

    userIsLoggedIn: (state) => {
      const token = cookies.get('token');
      if (token) {
        state.isLoggedIn = true;
      }
    },

    authHasNoAccess: (state) => {
      state.hasNoAccess = true;
    },

    authIsNotLoggedIn: () => {
      state.isLoggedIn = false;
    },
  },

  extraReducers: (builder) => {
    builder
      .addCase(adminLogin.fulfilled, (state, { payload }) => {
        state.me = payload;
        state.isLoggedIn = true;
        cookies.set('admin-token', payload.token, { path: '/' });
      })

      .addCase(adminLogout.fulfilled, (state) => {
        state.isLoggedIn = false;
        cookies.remove('admin-token');
      })

      .addCase(adminMe.fulfilled, (state, { payload }) => {
        state.me = payload;
        state.isLoggedIn = true;
      })

      .addCase(userLogin.fulfilled, (state, { payload }) => {
        state.me = payload;
        state.isLoggedIn = true;
        cookies.set('token', payload.token, { path: '/' });
      })

      .addCase(userLogout.fulfilled, (state) => {
        state.isLoggedIn = false;
        cookies.remove('token');
      })

      .addCase(userMe.fulfilled, (state, { payload }) => {
        state.me = payload;
        state.isLoggedIn = true;
      })
  },
});

export const { adminIsLoggedIn, userIsLoggedIn, authHasNoAccess, authIsNotLoggedIn } = authSlice.actions;

export default authSlice.reducer;