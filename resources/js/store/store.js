import { configureStore } from '@reduxjs/toolkit';
import app from './app';
import auth from './auth';
import billing from './billing';

export default configureStore({
  reducer: {
    app,
    auth,
    billing,
  },
});