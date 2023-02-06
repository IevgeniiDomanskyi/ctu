import Cookies from 'universal-cookie';
import { createAsyncThunk } from '@reduxjs/toolkit';
import store from './store';
import { appSetVersion, appSetMessage } from './app';
import { authIsNotLoggedIn, authHasNoAccess } from './auth';

const cookies = new Cookies();
const appUrl = 'http://localhost/';

export const request = (uri, method = 'GET') => {
  return createAsyncThunk(uri,
    async (payload = {}, { rejectWithValue }) => {
      try {
        const options = {
          method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
        };

        if (payload.data && (method.toUpperCase() === 'POST' || method.toUpperCase() === 'PUT')) {
          options.body = JSON.stringify(payload.data);
        }

        let token = cookies.get('token');
        if (uri.includes('admin/')) {
          token = cookies.get('admin-token');
        }

        if (token) {
          options.headers.Authorization = `Bearer ${token}`;
        }

        if (payload.params) {
          for (const key in payload.params) {
            uri = uri.replace(':' + key, payload.params[key])
          }
        }

        const response = await fetch(appUrl + uri, options);
        const result = await response.json();
        if (response.status == 200) {
          return resultHandler(result);
        }

        if (response.status == 401) {
          store.dispatch(authIsNotLoggedIn());
        }

        if (response.status == 403) {
          store.dispatch(authHasNoAccess());
        }

        throw result.messages;
      } catch (err) {
        messageHandler(err);
        return rejectWithValue('Server Error');
      }
    }
  );
};

const resultHandler = (result) => {
  const version = store.getState().app.version;
  if (version != null && version != result.version) {
    window.location.reload(true);
  }
  store.dispatch(appSetVersion(result.version));

  messageHandler(result.messages);

  return result.data;
}

const messageHandler = (messages) => {
  if (messages && messages.length) {
    for (const message of messages) {
      store.dispatch(appSetMessage(message));
    }
  }
}