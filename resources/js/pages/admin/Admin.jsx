import { useSelector, useDispatch } from 'react-redux';
import { adminMe, adminIsLoggedIn } from '@/store/auth';
import AppMessages from '@/components/AppMessages/AppMessages';
import AdminLayout from "./AdminLayout";
import LoginLayout from "./LoginLayout";
import { useEffect } from 'react';

const Admin = () => {
  const { isLoggedIn, me } = useSelector((state) => state.auth);
  const dispatch = useDispatch();

  const layoutComponent = () => {
    return (isLoggedIn ? <AdminLayout /> : <LoginLayout />);
  };

  useEffect(() => {
    if ( ! isLoggedIn) {
      dispatch(adminIsLoggedIn());
    }
  });

  useEffect(() => {
    if (isLoggedIn && ! me.id) {
      dispatch(adminMe({params: {id: 3, hash: 'test'}}));
    }
  }, [isLoggedIn]);

  return (
    <>
      { layoutComponent() }
      <AppMessages />
    </>
  );
}

export default Admin;