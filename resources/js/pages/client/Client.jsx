import { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { userMe, userIsLoggedIn } from '@/store/auth';
import AppMessages from '@/components/AppMessages/AppMessages';
import ClientLayout from "./ClientLayout";
import LoginLayout from "./LoginLayout";

const Client = () => {
  const { isLoggedIn, hasNoAccess, me } = useSelector((state) => state.auth);
  const dispatch = useDispatch();

  const layoutComponent = () => {
    if (hasNoAccess) {
      return <h1>Has No Access</h1>
    }
    return (isLoggedIn ? <ClientLayout /> : <LoginLayout />);
  };

  useEffect(() => {
    if ( ! isLoggedIn) {
      dispatch(userIsLoggedIn());
    }
  });

  useEffect(() => {
    if (isLoggedIn && ! me.id) {
      dispatch(userMe());
    }
  }, [isLoggedIn]);

  return (
    <>
      { layoutComponent() }
      <AppMessages />
    </>
  );
}

export default Client;