import { createSlice } from '@reduxjs/toolkit';
import { request } from './index';

export const billingSetupIndent = request('api/setup-indent');
export const billingSavePaymentMethod = request('api/save-payment-method', 'POST');

export const billingSlice = createSlice({
  name: 'billing',

  initialState: {
    indent: {},
  },

  reducers: {
  },

  extraReducers: (builder) => {
    builder
      .addCase(billingSetupIndent.fulfilled, (state, { payload }) => {
        state.indent = payload;
      })
  },
});

// export const { } = authSlice.actions;

export default billingSlice.reducer;